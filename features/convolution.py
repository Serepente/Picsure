import cv2
import numpy as np
import sys

# Load an image
image_path = sys.argv[1] 
image = cv2.imread(image_path)

#Smoothing
smooth_image = cv2.blur(image, (5, 5))  # Kernel size is 5x5
smooth_name = "assets/img/convolution/smoothedImage.jpg"
#Gaussian Blur
gaussian_blur_image = cv2.GaussianBlur(image, (5, 5), 0)  # Kernel size is 5x5
gaussian_blur_name = "assets/img/convolution/gaussianBlurredImage.jpg"

#Sharpening
# kernel = np.array([[0, -2, 0], [-2, 11, -2], [0, -2, 0]])
kernel = np.array([[0, -1, 0], [-1, 5, -1], [0, -1, 0]])
sharpened_image = cv2.filter2D(image, -1, kernel)
sharpened_name = "assets/img/convolution/sharpenedImage.jpg"
#Mean Removal
mean_removal_image = cv2.subtract(image, cv2.blur(image, (3,3)))
meanRemoval_name = "assets/img/convolution/meanImage.jpg"
#Emboss Laplacian
laplacian = cv2.Laplacian(image, cv2.CV_64F)
lapcianEmboss_name = "assets/img/convolution/lapcianEmboss.jpg"
#Other types of embossing
emboss_kernel = np.array([[0, -1, -1], [1, 0, -1], [1, 1, 0]])
embossed_image = cv2.filter2D(image, -1, emboss_kernel)
embossed_type_name = "assets/img/convolution/embossedImage.jpg"

# cv2.imshow("Original", image)
# cv2.imshow("Smooth image", smooth_image)
# cv2.imshow("Gaussian Blur Image", gaussian_blur_image)
# cv2.imshow("Sharpened Image", sharpened_image)
# cv2.imshow("Mean Removal Image", mean_removal_image)
# cv2.imshow("Laplacian Image", laplacian)
# cv2.imshow("Embossed Image", embossed_image)
cv2.imwrite(smooth_name, smooth_image)
cv2.imwrite(gaussian_blur_name, gaussian_blur_image)
cv2.imwrite(sharpened_name, sharpened_image)
cv2.imwrite(meanRemoval_name, mean_removal_image)
cv2.imwrite(lapcianEmboss_name, laplacian)
cv2.imwrite(embossed_type_name, embossed_image)


# Wait for a key press and close all OpenCV windows
cv2.waitKey(0)
cv2.destroyAllWindows()
