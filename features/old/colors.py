import cv2
import numpy as np
import sys

def find_color_regions(hsv_img, lower_bound, upper_bound):
    """Find regions of a specific color within the defined HSV range, including edges."""
    blurred_hsv_img = cv2.GaussianBlur(hsv_img, (5, 5), 0)

    edges = cv2.Canny(blurred_hsv_img, 50, 150)

    mask = cv2.inRange(blurred_hsv_img, lower_bound, upper_bound)
    mask = cv2.bitwise_or(mask, edges)

    kernel = np.ones((5, 5), np.uint8)
    mask = cv2.morphologyEx(mask, cv2.MORPH_OPEN, kernel)

    contours, _ = cv2.findContours(mask, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    min_area = 2000
    large_contours = [cnt for cnt in contours if cv2.contourArea(cnt) > min_area]
    cv2.drawContours(img, large_contours, -1, (0, 255, 0), 3)
    
    return len(large_contours)


image_path = 'shapes.jpg'
img = cv2.imread(image_path)

if img is None:
    sys.exit("Could not read the image.")

# Convert to HSV
hsv_img = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)

color_ranges = {
    "Red": ((0, 50, 20), (29, 255, 255)),
    "Green": ((55, 50, 50), (75, 255, 255)),
    "Blue": ((89, 50, 70), (128, 255, 255)),
    "Yellow": ((18, 40, 90), (30, 255, 255)),
}

color_regions = {color: find_color_regions(hsv_img, np.array(lower), np.array(upper))
                 for color, (lower, upper) in color_ranges.items()}

for color, count in color_regions.items():
    print(f"{color}: {count}")