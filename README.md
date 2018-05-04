# CS3380 Final Project

Created by Brian Cox and Ryan Wortmann

## Description

For our final project, we decided to create an elementary-school gradebook application that allows teachers to enter grades for their students.  When first accessing the site, teachers and students are both able to login with their own specific login information.  Once a teacher logs in, they are able to see all of their students and the grades they've created for their students.  They have the options of creating new grades, editing existing grades, and deleting existing grades; they are also capable of adding a new student to their class if need be.  Once that student logs in, they are able to view all of the grades that their teacher input for them.

## Schema

Table: teacher

|  #  |  Name       |  Type          |  Null  |  Default  |
|-----|-------------|----------------|--------|-----------|
|  1  |  ID         |  int           |  No    |  None     |
|  2  |  FirstName  |  varchar(50)   |  No    |  None     |
|  3  |  LastName   |  varchar(50)   |  No    |  None     |
|  4  |  Password   |  varchar(255)  |  No    |  None     |

Table: student

|  #  |  Name       |  Type          |  Null  |  Default  |
|-----|-------------|----------------|--------|-----------|
|  1  |  ID         |  int           |  No    |  None     |
|  2  |  FirstName  |  varchar(50)   |  No    |  None     |
|  3  |  LastName   |  varchar(50)   |  No    |  None     |
|  4  |  Password   |  varchar(255)  |  No    |  None     |
|  5  |  TeacherID  |  int           |  No    |  None     |

Table: grades

|  #  |  Name            |  Type         |  Null  |  Default  |
|-----|------------------|---------------|--------|-----------|
|  1  |  ID              |  int          |  No    |  None     |
|  2  |  StudentID       |  int          |  No    |  None     |
|  3  |  AssignmentName  |  varchar(50)  |  No    |  None     |
|  4  |  EarnedPoints    |  int          |  No    |  None     |
|  5  |  TotalPoints     |  int          |  No    |  None     |

## ERD Diagram

![ERD Diagram](docs/FinalProjectERD.png)

## CRUD

Create:

- **Create new students:** teachers can add new students
- **Create new grades:** teachers can add new grades for individual students

Read:

- **Read existing grades:** grades are displayed from database in a table on screen
- **Read existing teachers:** teacher data is read when logging in as teacher
- **Read existing students:** student data is read when logging in as student, list of students displayed on teacher gradebook page

Update:

- **Update existing grades:** teachers can add edit existing grades

Delete:

- **Delete existing grades:** teachers can delete existing grades

## Demo
