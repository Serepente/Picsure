import cv2
import numpy as np
import sys

image_path = sys.argv[1] 
image = cv2.imread(image_path)

# Define the translation matrix
# This will move the image 100 pixels to the right and 50 pixels down
Xtranslate = sys.argv[2] 
Ytranslate = sys.argv[3] 

translation_matrix = np.float32([[1, 0, Xtranslate], [0, 1, Ytranslate]])

# Apply the translation to the image
translated_image = cv2.warpAffine(image, translation_matrix, (image.shape[1], image.shape[0]))

translatedImg = 'translated_img.jpg'
cv2.imwrite(translatedImg, translated_image)

print(translatedImg)