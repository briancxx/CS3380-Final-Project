# Schema

## Grades

Table Schema:

- ID
- StudentID
- AssignmentID
- EarnedPoints

Functions:

- addGrade()
- editGrade()
- removeGrade()
- viewGradesStudent()
- viewGradesTeacher()

## Assignments

Table Schema:

- ID
- Name
- TotalPoints

Functions:

- addAssignment()
- removeAssignment()

## Students

Table Schema:

- ID
- FirstName
- LastName
- Username
- Password
- TeacherID

Functions:

- addStudent()
- loginStudent()

## Teachers

Table Schema:

- ID
- FirstName
- LastName
- Username
- Password

Functions:

- addTeacher()
- loginTeacher()
