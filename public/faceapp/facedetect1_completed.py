## detect face with coordinates and count them

# import packages
import cv2 #openCV
import sys

# Get user supplied values
imagePath = "face3.jpg"
cascPath = "haarcascade_frontalface_default.xml"

# Create the haar cascade
faceCascade = cv2.CascadeClassifier(cascPath)

# Read the image
image = cv2.imread(imagePath)
gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

# Detect faces in the image
faces = faceCascade.detectMultiScale(
    gray,
    scaleFactor=1.1,
    minNeighbors=5,
    minSize=(30, 30)
)

# print face coordinates
print (faces)

count = 0
# Draw a rectangle around the faces
for (x, y, w, h) in faces:
    count = count + 1
    cv2.rectangle(image, (x, y), (x+w, y+h), (0, 255, 0), 2)

# print face count
print(count)


