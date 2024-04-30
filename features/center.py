import cv2
import numpy as np
import sys

image_path = sys.argv[1]
image = cv2.imread(image_path)

cv2.rectangle(image, (0, 0), (image.shape[1] - 1, image.shape[0] - 1), (0, 0, 255), 5)

mask = np.zeros(image.shape[:2], np.uint8)
bgd_model = np.zeros((1, 65), np.float64)
fgd_model = np.zeros((1, 65), np.float64)
rect = (50, 50, image.shape[1] - 50, image.shape[0] - 50)
cv2.grabCut(image, mask, rect, bgd_model, fgd_model, 5, cv2.GC_INIT_WITH_RECT)

mask2 = np.where((mask == 2) | (mask == 0), 0, 1).astype('uint8')

contours, _ = cv2.findContours(mask2, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)

marked_image = image.copy()

for contour in contours:
    x, y, w, h = cv2.boundingRect(contour)

    M = cv2.moments(contour)
    centroid_x = int(M['m10'] / M['m00']) if M['m00'] != 0 else None
    centroid_y = int(M['m01'] / M['m00']) if M['m00'] != 0 else None

    if centroid_x is not None and centroid_y is not None:
        cv2.rectangle(marked_image, (x, y), (x + w, y + h), (0, 255, 0), 2)
        cv2.drawMarker(marked_image, (centroid_x, centroid_y), color=(0, 0, 255), markerType=cv2.MARKER_CROSS,
                       markerSize=10, thickness=2)

        print(f"Centroid Coordinates: ({centroid_x}, {centroid_y})")
    else:
        print("No centroid detected for this object")

# cv2.imshow("Marked Image with Centroids and Bounding Boxes", marked_image)
# cv2.waitKey(0)
cv2.imwrite('boxes.jpg', marked_image)

cv2.destroyAllWindows()
