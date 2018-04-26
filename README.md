# CS3380 Final Project

Created by Brian Cox and Ryan Wortmann

## Description

For our final project, we decided to create a elementary-school gradebook application that allows teachers to enter assignments, create assignments, and add grades for their students.  Each teacher has the ability to create a login for each of their students, and one student login is assigned to one teacher.  If a teacher logs in, they will be able to see all of their students' grades; if a student logs in, they will be able to see only their grades.

## Schema

Table: teachers

#  |  Name       |  Type          |  Null  |  Default
-------------------------------------------------------
1  |  ID         |  int           |  No    |  None
2  |  FirstName  |  varchar(50)   |  No    |  None
3  |  LastName   |  varchar(50)   |  No    |  None
4  |  Username   |  varchar(50)   |  No    |  None
5  |  Password   |  varchar(255)  |  No    |  None

Table: students

#  |  Name       |  Type          |  Null  |  Default
-------------------------------------------------------
1  |  ID         |  int           |  No    |  None
2  |  FirstName  |  varchar(50)   |  No    |  None
3  |  LastName   |  varchar(50)   |  No    |  None
4  |  Username   |  varchar(50)   |  No    |  None
5  |  Password   |  varchar(255)  |  No    |  None
6  |  TeacherID  |  int           |  No    |  None

Table: assignments

#  |  Name         |  Type         |  Null  |  Default
--------------------------------------------------------
1  |  ID           |  int          |  No    |  None
2  |  Name         |  varchar(50)  |  No    |  None
3  |  TotalPoints  |  int          |  No    |  None

Table: grades

#  |  Name          |  Type  |  Null  |  Default
--------------------------------------------------
1  |  ID            |  int   |  No    |  None
2  |  StudentID     |  int   |  No    |  None
3  |  AssignmentID  |  int   |  No    |  None
4  |  EarnedPoints  |  int   |  No    |  None

## ERD Diagram

## CRUD

Create:

-
-

Read:

-
-

Update:

- 
-

Delete:

-
-

## Demo
