## detect face and draw rectangles

# import packages
import cv2
import sys
import os
import json
import os.path
from os import path

import pathlib
p = os.path.dirname(os.path.abspath(__file__))


# Get user supplied values
imagePath = sys.argv[1]
c_path = sys.argv[2]
filename = sys.argv[3]
name = sys.argv[4]

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

count = 0
# Draw a rectangle around the faces
for (x, y, w, h) in faces:
	count = count + 1
    cv2.rectangle(image, (x, y), (x+w, y+h), (0, 255, 0), 2)

data = {name:0}
if(path.exists(filename)):
	with open(filename, "r") as read_file:
		data=json.load(read_file)


data[name] = count


with open(filename, "w") as write_file:
    json.dump(data, write_file)

# Saving the image 
cv2.imwrite(imagePath, image)
print(imagePath)



