## detect face and draw rectangles

# import packages
import cv2
import sys
import os

import pathlib
p = os.path.dirname(os.path.abspath(__file__))


# Get user supplied values
rel_path = sys.argv[1]
c_path = sys.argv[2]

imagePath =os.path.join(p, rel_path)

#cascPath = "haarcascade_frontalface_default.xml"

cascPath = os.path.join(p, c_path)

# Create the haar cascade
faceCascade = cv2.CascadeClassifier(cascPath)

# Read the image & convert to gray scale
image = cv2.imread(imagePath)
gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

# Detect faces in the image
faces = faceCascade.detectMultiScale(
    gray,
    scaleFactor=1.1,
    minNeighbors=5,
    minSize=(30, 30)
)

# Draw a rectangle around the faces
for (x, y, w, h) in faces:
    cv2.rectangle(image, (x, y), (x+w, y+h), (0, 255, 0), 2)


# Saving the image 
cv2.imwrite(imagePath, image)
print(imagePath)



