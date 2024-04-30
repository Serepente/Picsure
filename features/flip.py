import cv2
import sys


image_path = sys.argv[1] 
img = cv2.imread(image_path)
# img = cv2.imread("apol.jpg")


# Mirror the image vertically
flipVal = sys.argv[2]
if(flipVal):
    if(flipVal == '0'):
        mirrored_img_vertical = cv2.flip(img, 0)
    else:
        mirrored_img_vertical = cv2.flip(img, 1)

    mirrored_img = "assets/img/mirrored/mirrored_img.jpg"
    cv2.imwrite(mirrored_img, mirrored_img_vertical)
    print(mirrored_img)
