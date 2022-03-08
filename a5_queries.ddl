-- ============== UNIVERSITY DATABASE QUERIES: A5 ==============

-- 1) Show a list of course ids, section ids, semester and room numbers as well
-- as the year for all courses held in 2008 and beyond.

select course_id, sec_id, semester, room_no, year from section
where year >= 2008;

-- 2) Make a list of department names and the name of the building associated
-- with the department along with the course_ids and course titles taught by each
-- department.

select d.dept_name, d.building, c.course_id, c.title
from department as d, course as c where d.dept_name = c.dept_name;

-- 3) Which courses are taught by Professor Crick?  List the unique course_ids
-- only.

select t.course_id from teaches as t, instructor as i
where t.ID = i.ID and i.name = "Crick";

-- 4) Make a list of the names of the instructors and the names of the students
--  that they advise.  Your results should have two (labelled) columns: Instructor
--  and Student.

select i.name as Instructor, s.name as Student
from advisor as a, student as s, instructor as i
where a.s_id = s.ID and a.i_id = i.ID;

-- 5) Make a list of students names, course_id and their grades in all courses
-- they took in 2009.  Include only students associated with the Finance or
-- Physics departments.  You do not need to include students who did not take
-- courses in 2009.

select s.name, t.course_id, t.grade from takes as t, student as s
where s.ID = t.ID
and t.year = 2009 and (s.dept_name = "Finance" or s.dept_name = "Physics");

-- 6) How many courses have been taken by the student named "Levy"?   Count all
-- courses, including any duplicates.

select count(*) as taken_by_Levy from student as s, takes as t
where t.ID = s.ID and s.name = "Levy"
group by s.name;

-- 7) Make a list of the departments along with the number of professors in each
-- department and the average salary of the professors in that department.  Call
-- the columns DeptName, NumProfs and AvgSalary.

select dept_name as DeptName, count(ID) as NumProfs, avg(salary) as AvgSalary
from instructor group by dept_name;

-- 8) List the name and ID of each course in the database and the ID of the
-- course prerequisite, if they have one.  In mysql, left/right joins implement
-- outer joins that we used in relational algebra.

select c.title as name, c.course_id, p.prereq_id from course as c
left outer join prereq as p on c.course_id = p.course_id;

-- 9) Make a list of courses (course ids) that were offered in both Fall 2009
-- and in Spring 2010.   (This does not mean either/or, but courses that were
-- offered in both semesters)

select course_id from section where (semester = "Fall" and year = 2009)
and course_id in (select course_id from section
where (semester = "Spring" and year = 2010));

-- 10)  Show the names and salaries of all professors who make more than the
-- average salary at the university.

select name, salary from instructor
where salary > (select avg(salary) from instructor);
