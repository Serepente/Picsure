import cv2
import numpy as np
import json
import sys

image_path = sys.argv[1] 
image = cv2.imread(image_path)

mask = np.zeros(image.shape[:2], np.uint8)
bgd_model = np.zeros((1, 65), np.float64)
fgd_model = np.zeros((1, 65), np.float64)
rect = (50, 50, image.shape[1] - 50, image.shape[0] - 50)
cv2.grabCut(image, mask, rect, bgd_model, fgd_model, 5, cv2.GC_INIT_WITH_RECT)

mask2 = np.where((mask == 2) | (mask == 0), 0, 1).astype('uint8')

moments = cv2.moments(mask2, True)
centroid_x = int(moments['m10'] / moments['m00']) if moments['m00'] != 0 else None
centroid_y = int(moments['m01'] / moments['m00']) if moments['m00'] != 0 else None

segmented_image = image * mask2[:, :, np.newaxis]

if np.count_nonzero(mask2) > 0:
    object_size_pixels = np.count_nonzero(mask2)
    print(f"Segmented object size: {object_size_pixels} pixels")
else:
    print("No object detected")

if centroid_x is not None and centroid_y is not None:
    cv2.drawMarker(segmented_image, (centroid_x, centroid_y), color=(0, 255, 0), markerType=cv2.MARKER_CROSS, markerSize=20, thickness=2)
    print(f"Centroid Coordinates: ({centroid_x}, {centroid_y})")
else:
    print("No object detected")

mask = (segmented_image[:, :, 0] < 50) & (segmented_image[:, :, 1] < 50) & (segmented_image[:, :, 2] < 50)
segmented_image[mask] = [255, 255, 255] 
cv2.imwrite('centroid.jpg', segmented_image)

# cv2.imshow("Segmented Image with Centroid", segmented_image)
# cv2.waitKey(0)

image_height, image_width, _ = image.shape

image_size_pixels = image_height * image_width
print(f"Image size: {image_size_pixels} pixels")

sizes_info = {"object_size": object_size_pixels, "image_height": image_height, "image_width": image_width, "image_size_pixel": image_size_pixels, "centroid_x": centroid_x, "centroid_y": centroid_y}
with open('assets/json/sizes_info.json', 'w') as json_file:
    json.dump(sizes_info, json_file)

cv2.destroyAllWindows()

# # image_path = 'apol.jpg'
# image = cv2.imread(image_path)
angleValue = sys.argv[2] 
print(f"Angle Value: {angleValue}")

# angle = angleValue

# height, width = image.shape[:2]

# rotation_matrix = cv2.getRotationMatrix2D((width / 2, height / 2), angleValue, 1)

# rotated_image = cv2.warpAffine(image, rotation_matrix, (width, height))

# cv2.imwrite('rotated.jpg', rotated_image)
