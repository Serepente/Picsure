import cv2
import numpy as np
import os
import sys
import json
import random
import string
import matplotlib.pyplot as plt


shape_counts = {"Triangle": 0, "Quadrilateral": 0, "Square": 0, "Rectangle": 0, "Diamond": 0, "Pentagon": 0, "Hexagon": 0, "Octagon": 0, "Oblong": 0, "Star": 0, "Circle": 0, "Total": 0}

def find_shape(approx, area):
    _, _, w, h = cv2.boundingRect(approx)
    aspect_ratio = w / float(h)
    
    variance_threshold = 0.2 
    cx = np.mean(approx[:, 0, 0])
    cy = np.mean(approx[:, 0, 1])
    distances = np.sqrt((approx[:, 0, 0] - cx)**2 + (approx[:, 0, 1] - cy)**2)
    variance = np.var(distances)
    
    if variance > variance_threshold:
        shape_counts["Diamond"] += 1
        shape_label = "Diamond" if area < small_diamond_area_threshold else "Diamond"
    elif 0.95 <= aspect_ratio <= 1.75:
        shape_counts["Square"] += 1
        shape_label = "Square"
    else:
        shape_counts["Rectangle"] += 1
        shape_label = "Rectangle"
        
    return shape_label

def is_oblong(contour, threshold_ratio=1.5):
    ellipse = cv2.fitEllipse(contour)
    (center, axes, orientation) = ellipse
    major_axis_length = max(axes)
    minor_axis_length = min(axes)
    ratio = major_axis_length / minor_axis_length
    return ratio > threshold_ratio

def find_color_regions(hsv_img, lower_bound, upper_bound):
    """Find regions of a specific color within the defined HSV range, including edges."""
    blurred_hsv_img = cv2.GaussianBlur(hsv_img, (5, 5), 0)

    edges = cv2.Canny(blurred_hsv_img, 50, 150)

    mask = cv2.inRange(blurred_hsv_img, lower_bound, upper_bound)
    mask = cv2.bitwise_or(mask, edges)

    kernel = np.ones((5, 5), np.uint8)
    mask = cv2.morphologyEx(mask, cv2.MORPH_OPEN, kernel)

    contours, _ = cv2.findContours(mask, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    min_area = 1500
    large_contours = [cnt for cnt in contours if cv2.contourArea(cnt) > min_area]
    cv2.drawContours(img, large_contours, -1, (0, 255, 0), 3)
    
    return len(large_contours)


image_path = sys.argv[1] 
# image_path = "edges.png "
img = cv2.imread(image_path)
threshold = 50

mask = (img[:, :, 0] < threshold) & (img[:, :, 1] < threshold) & (img[:, :, 2] < threshold)
img[mask] = [255, 255, 255]

output_path = 'processed_sequence'
os.makedirs(output_path, exist_ok=True)
blurred_img = cv2.GaussianBlur(img, (5, 5), 0)
imgGrey = cv2.cvtColor(blurred_img, cv2.COLOR_BGR2GRAY)
_, thrash = cv2.threshold(imgGrey, 230, 255, cv2.THRESH_BINARY_INV)
contours, hierarchy = cv2.findContours(thrash, cv2.RETR_TREE, cv2.CHAIN_APPROX_SIMPLE)
# cv2.drawContours(img, [approx], 0, (0, 0, 0), 5)

small_diamond_area_threshold = 1000 

    
def put_label(cv_img, text, contour):
    M = cv2.moments(contour)
    if M['m00'] != 0:
        cx = int(M['m10'] / M['m00'])
        cy = int(M['m01'] / M['m00'])

        font = cv2.FONT_HERSHEY_SIMPLEX
        
        # Border settings
        border_thickness = 5
        border_color = (0, 0, 0)  # Black
        
        # Text settings
        text_thickness = 3
        bg_types = sys.argv[2] 
        if bg_types == 'black':
            text_color = (255, 255, 0)
        else:
            text_color = (0, 0, 0)
        
        # Draw the border (background of the text)
        cv2.putText(cv_img, text, (cx, cy), font, 1, border_color, border_thickness)
        
        # Draw the actual text
        cv2.putText(cv_img, text, (cx, cy), font, 1, text_color, text_thickness)
        # cv2.putText(cv_img, text, (cx, cy), cv2.FONT_HERSHEY_SIMPLEX, 1, (255, 0, 0), 2)
    return cv_img

labelled_images = []

for i, contour in enumerate(contours):
    area = cv2.contourArea(contour)
    if area > 100:  
        approx = cv2.approxPolyDP(contour, 0.03 * cv2.arcLength(contour, True), True)
        if len(approx) == 4:
            shape_counts["Total"] += 1
            shape_counts["Quadrilateral"] += 1
            shape_label = find_shape(approx, area)
            put_label(img, shape_label, contour)
        elif len(approx) == 3:
            shape_counts["Triangle"] += 1
            shape_counts["Total"] += 1
            put_label(img, "Triangle", contour)
        elif len(approx) == 5:
            shape_counts["Pentagon"] += 1
            shape_counts["Total"] += 1
            put_label(img, "Pentagon", contour)
        elif len(approx) == 6:
            shape_counts["Hexagon"] += 1
            shape_counts["Total"] += 1
            put_label(img, "Hexagon", contour)
        elif len(approx) == 10:
            shape_counts["Star"] += 1
            shape_counts["Total"] += 1
            put_label(img, "Star", contour)
        else:
            shape_counts["Total"] += 1
            if is_oblong(contour):
                shape_counts["Oblong"] += 1
                put_label(img, "Oblong", contour)
            else:
                shape_counts["Circle"] += 1
                put_label(img, "Circle", contour)
    intermediate_image_path = f'{output_path}/step_{i}.png'
    bg_type = sys.argv[2] 
    if bg_type == 'black':
        white_background_mask = (img[:, :, 0] > 200) & (img[:, :, 1] > 200) & (img[:, :, 2] > 200) 
        img[white_background_mask] = [0, 0, 0]

    cv2.imwrite(intermediate_image_path, img)
    labelled_images.append(intermediate_image_path)

with open('assets/json/shape_counts.json', 'w') as f:
    json.dump(shape_counts, f)

frame = cv2.imread(labelled_images[0])
# height, width, layers = frame.shape
# video_name = 'labelled_video.avi'
# video = cv2.VideoWriter(video_name, 0, 1, (width, height))
height, width, layers = frame.shape
fourcc = cv2.VideoWriter_fourcc(*'avc1')
random_letters = ''.join(random.choice(string.ascii_letters) for _ in range(5))
video_name = f'assets/vids/labelled_video_{random_letters}.mp4'
video = cv2.VideoWriter(video_name, fourcc, 1, (width, height))

for image in labelled_images:
    video.write(cv2.imread(image))

cv2.destroyAllWindows()
video.release()

video_info = {"video_name": video_name}
with open('assets/json/video_info.json', 'w') as json_file:
    json.dump(video_info, json_file)


hsv_img = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)

color_ranges = {
    "Red": ((0, 50, 20), (0, 255, 255)),
    "Green": ((55, 50, 50), (75, 255, 255)),
    "Blue": ((89, 50, 70), (128, 255, 255)),
    "Yellow": ((18, 40, 90), (30, 255, 255)),
}

color_regions = {color: find_color_regions(hsv_img, np.array(lower), np.array(upper))
                 for color, (lower, upper) in color_ranges.items()}

with open('assets/json/color_counts.json', 'w') as f:
    json.dump(color_regions, f)

imgs = cv2.imread(image_path)

bgss_type = sys.argv[2] 
if bgss_type == 'black':
    white_background_masks = (imgs[:, :, 0] > 50) & (imgs[:, :, 1] > 50) & (imgs[:, :, 2] > 50) 
    imgs[mask] = [255, 255, 255]
    cv2.imwrite('neat.jpg', imgs)
else:
    mask = (imgs[:, :, 0] < 200) & (imgs[:, :, 1] < 200) & (imgs[:, :, 2] < 200)
    imgs[mask] = [0, 0, 0] 
    cv2.imwrite('neat.jpg', imgs)
    