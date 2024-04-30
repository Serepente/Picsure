import sys
import numpy as np
import cv2

# image_path = sys.argv[1]

img = cv2.imread('image/shape3.jpg')
imgGrey = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
_, thrash = cv2.threshold(imgGrey, 240, 255, cv2.THRESH_BINARY)
contours, _ = cv2.findContours(thrash, cv2.RETR_TREE, cv2.CHAIN_APPROX_NONE)

# Initialize a dictionary to count shapes
shape_counts = {"Triangle": 0, "Square": 0, "Rectangle": 0, "Pentagon": 0, "Hexagon": 0, "Octagon": 0, "Star": 0, "Circle": 0}

for contour in contours:
    approx = cv2.approxPolyDP(contour, 0.01* cv2.arcLength(contour, True), True)
    shape_type = ""
    if len(approx) == 3:
        shape_type = "Triangle"
    elif len(approx) == 4:
        x1, y1, w, h = cv2.boundingRect(approx)
        aspectRatio = float(w) / h
        if aspectRatio >= 0.95 and aspectRatio <= 1.05:
            shape_type = "Square"
        else:
            shape_type = "Rectangle"
    elif len(approx) == 5:
        shape_type = "Pentagon"
    elif len(approx) == 6:
        shape_type = "Hexagon"
    elif len(approx) == 8:
        shape_type = "Octagon"
    elif len(approx) == 10:
        shape_type = "Star"
    else:
        shape_type = "Circle"
    
    # Draw the contour and label the shape on the image
    cv2.drawContours(img, [approx], 0, (0, 0, 0), 5)
    x = approx.ravel()[0]
    y = approx.ravel()[1] - 5
    cv2.putText(img, shape_type, (x, y), cv2.FONT_HERSHEY_COMPLEX, 0.5, (0, 0, 0))
    
    # Update the shape count
    if shape_type in shape_counts:
        shape_counts[shape_type] += 1

cv2.imwrite('processed_image2.jpg', img)

# Print out the counts of each shape
for shape, count in shape_counts.items():
    print(f"{shape}: {count}")
