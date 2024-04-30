import cv2
import matplotlib.pyplot as plt
import sys
import numpy as np
import json

image_path = sys.argv[1] 
img = cv2.imread(image_path)
b, g, r = cv2.split(img)

plt.figure(figsize=(12, 6))

plt.subplot(221)
plt.hist(b.ravel(), 256, [0, 256], color='blue')
plt.title('Blue Color Histogram')
plt.xlabel('Pixel Value')
plt.ylabel('Frequency')

plt.subplot(222)
plt.hist(g.ravel(), 256, [0, 256], color='green')
plt.title('Green Color Histogram')
plt.xlabel('Pixel Value')
plt.ylabel('Frequency')

plt.subplot(223)
plt.hist(r.ravel(), 256, [0, 256], color='red')
plt.title('Red Color Histogram')
plt.xlabel('Pixel Value')
plt.ylabel('Frequency')

# Convert the image to grayscale
gray_img = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)

plt.subplot(224)
plt.hist(gray_img.ravel(), 256, [0, 256], color='black')
plt.title('Black (Grayscale) Histogram')
plt.xlabel('Pixel Value')
plt.ylabel('Frequency')

plt.tight_layout()
# plt.show()
histogram_img = "assets/histogram/histogram_plot.png"
plt.savefig(histogram_img)
# print(histogram_img)

# Binary Projection
img = cv2.imread(image_path,0)

ret, img_bin = cv2.threshold(img, 127, 255, cv2.THRESH_BINARY)

horizontal_projection = np.sum(img_bin, axis=1)

vertical_projection = np.sum(img_bin, axis=0)

plt.figure(figsize=(10,8))

plt.subplot(2, 1, 1)
plt.hist(horizontal_projection, bins=256, color='black')
plt.gca().invert_yaxis()
plt.gca().set_facecolor('white')
plt.grid(color='gray', linestyle='--', linewidth=0.5)
plt.title('Horizontal Projection')

plt.subplot(2, 1, 2)
plt.hist(vertical_projection, bins=256, color='black')
plt.gca().set_facecolor('white')
plt.grid(color='gray', linestyle='--', linewidth=0.5)
plt.title('Vertical Projection')

# plt.show()
binaryProjection_img = "assets/histogram/binaryProjection_img.png"
plt.savefig(binaryProjection_img)
plt.close() 


data = {
    "histogramGraph": histogram_img,
    "binaryProjection": binaryProjection_img,
    # add more data if needed
}

# Convert data to JSON
json_data = json.dumps(data)

print(json_data)
plt.close() 


