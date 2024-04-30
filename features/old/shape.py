# import sys
import numpy as np
import cv2
import json

# Load the image
image_path = 'edges.png'

# image_path = sys.argv[1] 
# image_type = sys.argv[2] 

img = cv2.imread(image_path)
# if image_type == 'white':
imgGrey = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY) #color space to a grayscale image
    # 150, 255
_, thrash = cv2.threshold(imgGrey, 230, 255, cv2.THRESH_BINARY) #applies a binary thresholding operation to the grayscale image 150 to 255 white
contours, _ = cv2.findContours(thrash, cv2.RETR_TREE, cv2.CHAIN_APPROX_NONE) #detects the contours
# else:
    # imgGrey = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    # thrash = cv2.adaptiveThreshold(imgGrey, 255, cv2.ADAPTIVE_THRESH_GAUSSIAN_C, 
    #                            cv2.THRESH_BINARY_INV, 5, 2)
    # contours, _ = cv2.findContours(thrash, cv2.RETR_TREE, cv2.CHAIN_APPROX_NONE)

largest_area = 0
largest_contour_index = -1
for i, contour in enumerate(contours):
    area = cv2.contourArea(contour)
    if area > largest_area:
        largest_area = area
        largest_contour_index = i

shape_counts = {"Triangle": 0, "Quadrilateral": 0, "Square": 0, "Rectangle": 0, "Pentagon": 0, "Hexagon": 0, "Octagon": 0, "Star": 0, "Circle": 0}

for i, contour in enumerate(contours):

    if i == largest_contour_index:
        continue
    
    approx = cv2.approxPolyDP(contour, 0.03 * cv2.arcLength(contour, True), True)
    x = approx.ravel()[0]
    y = approx.ravel()[1] - 5
    if len(approx) == 3:
        shape_counts["Triangle"] += 1
        cv2.putText(img, "Triangle", (x, y), cv2.FONT_ITALIC, 0.5, (0, 0, 0))
    elif len(approx) == 4:
        shape_counts["Quadrilateral"] += 1
        x, y, w, h = cv2.boundingRect(approx)
        aspectRatio = float(w) / h
        square_margin = 1.00 
        if 1 - square_margin <= aspectRatio <= 1 + square_margin:
            # shape_counts["Quadrilateral"] += 1
            shape_counts["Square"] += 1
            cv2.putText(img, "Square", (x, y), cv2.FONT_ITALIC, 0.5, (0, 0, 0))
        elif not (1 - square_margin <= aspectRatio <= 1 + square_margin):
            # shape_counts["Quadrilateral"] += 1
            shape_counts["Rectangle"] += 1
            cv2.putText(img, "Rectangle", (x, y), cv2.FONT_ITALIC, 0.5, (0, 0, 0))
        else:
            cv2.putText(img, "Quadrilateral", (x, y), cv2.FONT_ITALIC, 0.5, (0, 0, 0))
    elif len(approx) == 5:
        shape_counts["Pentagon"] += 1
        cv2.putText(img, "Pentagon", (x, y), cv2.FONT_ITALIC, 0.5, (0, 0, 0))
    elif len(approx) == 6:
        shape_counts["Hexagon"] += 1
        cv2.putText(img, "Hexagon", (x, y), cv2.FONT_ITALIC, 0.5, (0, 0, 0))
    elif len(approx) == 10:
        shape_counts["Star"] += 1
        cv2.putText(img, "Star", (x, y), cv2.FONT_ITALIC, 0.5, (0, 0, 0))
    else:
        shape_counts["Circle"] += 1
        cv2.putText(img, "Circle", (x, y), cv2.FONT_ITALIC, 0.5, (0, 0, 0))

    cv2.drawContours(img, [approx], 0, (255, 255, 255), 1)

cv2.imwrite('processed_image3.jpg', img)

with open('shape_counts.json', 'w') as f:
    json.dump(shape_counts, f)
# 
def find_color_regions(hsv_img, color_ranges, min_area=39):
    """Find regions of specific colors within the defined HSV ranges."""
    total_count = 0
    for lower_bound, upper_bound in color_ranges:
        blurred_hsv_img = cv2.GaussianBlur(hsv_img, (5, 5), 0)
        mask = cv2.inRange(blurred_hsv_img, np.array(lower_bound), np.array(upper_bound))
        kernel = np.ones((5, 5), np.uint8)
        mask = cv2.morphologyEx(mask, cv2.MORPH_OPEN, kernel)
        contours, _ = cv2.findContours(mask, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
        large_contours = [cnt for cnt in contours if cv2.contourArea(cnt) >= min_area]
        total_count += len(large_contours)
    return total_count



hsv_img = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)

color_ranges = {
    "Red": [((0, 50, 50), (0, 255, 255))],
    "Green": [((36, 50, 50), (75, 255, 255))],
    "Blue": [((89, 50, 70), (128, 255, 255))],
    "Yellow": [((18, 40, 90), (30, 255, 255))],
}

color_regions = {color: find_color_regions(hsv_img, ranges) for color, ranges in color_ranges.items()}

# Output counts
with open('color_counts.json', 'w') as f:
    json.dump(color_regions, f)
