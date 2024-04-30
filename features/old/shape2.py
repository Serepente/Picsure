import sys
import numpy as np
import cv2
import json


image_path = sys.argv[1] 

img = cv2.imread(image_path)
imgGrey = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
_, thrash = cv2.threshold(imgGrey, 240, 255, cv2.THRESH_BINARY)
contours, _ = cv2.findContours(thrash, cv2.RETR_TREE, cv2.CHAIN_APPROX_NONE)

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
    
    approx = cv2.approxPolyDP(contour, 0.01 * cv2.arcLength(contour, True), True)
    x = approx.ravel()[0]
    y = approx.ravel()[1] - 5
    if len(approx) == 3:
        shape_counts["Triangle"] += 1
        cv2.putText(img, "Triangle", (x, y), cv2.FONT_ITALIC, 0.7, (0, 0, 0))
    elif len(approx) == 4:
        shape_counts["Quadrilateral"] += 1
        x, y, w, h = cv2.boundingRect(approx)
        aspectRatio = float(w) / h
        square_margin = 0.50 
        if 1 - square_margin <= aspectRatio <= 1 + square_margin:
            shape_counts["Square"] += 1
            cv2.putText(img, "Square", (x, y), cv2.FONT_ITALIC, 0.7, (0, 0, 0))
        elif 1 - square_margin >= aspectRatio >= 1 + square_margin:
            shape_counts["Rectangle"] += 1
            cv2.putText(img, "Rectangle", (x, y), cv2.FONT_ITALIC, 0.7, (0, 0, 0))
    elif len(approx) == 5:
        shape_counts["Pentagon"] += 1
        cv2.putText(img, "Pentagon", (x, y), cv2.FONT_ITALIC, 0.7, (0, 0, 0))
    elif len(approx) == 6:
        shape_counts["Hexagon"] += 1
        cv2.putText(img, "Hexagon", (x, y), cv2.FONT_ITALIC, 0.7, (0, 0, 0))
    elif len(approx) == 8:
        shape_counts["Octagon"] += 1
        cv2.putText(img, "Octagon", (x, y), cv2.FONT_ITALIC, 0.7, (0, 0, 0))
    elif len(approx) == 10:
        shape_counts["Star"] += 1
        cv2.putText(img, "Star", (x, y), cv2.FONT_ITALIC, 0.7, (0, 0, 0))
    else:
        shape_counts["Circle"] += 1
        cv2.putText(img, "Circle", (x, y), cv2.FONT_ITALIC, 0.7, (0, 0, 0))

    cv2.drawContours(img, [approx], 0, (255, 255, 255), 1)

cv2.imwrite('processed_image3.jpg', img)

with open('shape_counts.json', 'w') as f:
    json.dump(shape_counts, f)

# Color
def find_color_regions(hsv_img, lower_bound, upper_bound):
    """Find regions of a specific color within the defined HSV range."""
    # Apply a Gaussian blur to smooth out the image
    blurred_hsv_img = cv2.GaussianBlur(hsv_img, (5, 5), 0)
    mask = cv2.inRange(blurred_hsv_img, lower_bound, upper_bound)
    # Erode and dilate the mask to remove noise
    kernel = np.ones((5, 5), np.uint8)
    mask = cv2.morphologyEx(mask, cv2.MORPH_OPEN, kernel)
    contours, _ = cv2.findContours(mask, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    # Filter contours by area
    min_area = 500  # Adjust this value based on your image's scale and content
    large_contours = [cnt for cnt in contours if cv2.contourArea(cnt) > min_area]
    return len(large_contours)

# Load the image
# image = sys.argv[1] 
# img = cv2.imread(img)
# Convert to HSV
hsv_img = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)

# Define HSV range for each color with slightly adjusted ranges for green
color_ranges = {
    "Red": ((0, 50, 20), (5, 255, 255)),
    "Green": ((36, 50, 50), (75, 255, 255)),  # Adjusted green range for clarity
    "Blue": ((89, 50, 70), (128, 255, 255)),
    "Yellow": ((18, 40, 90), (30, 255, 255)),
}

# Find regions for each color range
color_regions = {color: find_color_regions(hsv_img, np.array(lower), np.array(upper))
                 for color, (lower, upper) in color_ranges.items()}

# Print out the counts of regions for each color
for color, count in color_regions.items():
    print(f"{color}: {count}")
