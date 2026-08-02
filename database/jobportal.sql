create database jobportal;
use jobportal;
create table users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username varchar(100) NOT NULL,
    email varchar(100) NOT NULL,
    password varchar(100) NOT NULL
    );

    CREATE TABLE companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(100) NOT NULL,
    location VARCHAR(100) NOT NULL
);

CREATE TABLE jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    job_type VARCHAR(50) NOT NULL,
    location VARCHAR(100) NOT NULL,
    salary VARCHAR(100),
    description TEXT,
    
    FOREIGN KEY (company_id) 
    REFERENCES companies(id)
);
INSERT INTO companies (company_name, location)
VALUES
('TechCorp Solutions Ltd.', 'Dhaka'),
('CreativeLab Interactive', 'Remote'),
('SoftMind Innovations', 'Mirpur, Dhaka'),
('Aura Media Agency', 'Remote'),
('Alpha Testing Lab', 'Remote'),
('DevsSquad Bangladesh', 'Banani, Dhaka'),
('Creative Media Studio', 'Remote'),
('SecureNet Core Systems', 'Remote'),
('DataNexus Global', 'Gulshan, Dhaka');







INSERT INTO jobs 
(company_id, title, job_type, location, salary, description)
VALUES

(1, 'Senior Frontend Engineer', 'Full-Time', 'Dhaka, BD', '$70k - $90k',
'Build elegant, fluid web environments using CSS Grid, Flexbox, and modern component systems safely.'),

(2, 'UI/UX Interface Architect', 'Remote', 'Global Remote', '$85k - $105k',
'Design high-fidelity interactive user interfaces, visual design trees, and responsive design mockups.'),

(3, 'Web Developer Intern', 'Internship', 'Mirpur, Dhaka', '৳12,000 /mo',
'Gain professional experience translating Figma mockups into clean, semantic HTML5/CSS3 modules.'),

(4, 'Graphic Design Intern', 'Internship', 'Part-Time Remote', '৳10,000 /mo',
'Looking for a creative student to develop marketing vectors, brand banners, and social layout assets using Photoshop and Illustrator.'),

(5, 'Code Editor & QA Assistant', 'Part-Time', 'Remote (BD)', '৳15,000 /mo',
'Review raw script files, clean up formatting rules, audit code comments, and log bug tickets before production deployments.'),

(6, 'Junior Web Developer', 'Entry-Level', 'Banani, Dhaka', '৳25,000 /mo',
'Join an active agile team to assist in managing core layouts, updating CSS media queries, and running standard version control routines.'),

(7, 'Content Writer', 'Part-Time', 'Remote (BD)', '৳18,000 /mo',
'Write engaging blog posts, website content, and social media captions. Strong writing skills and creativity are preferred.'),

(8, 'Cybersecurity Threat Analyst', 'Remote', 'Global Remote', '$95k - $120k',
'Monitor cloud firewalls, perform vulnerability architecture scans, and engineer custom defenses against threat matrix attacks.'),

(9, 'DevOps & Cloud Engineer', 'Full-Time', 'Gulshan, Dhaka', '৳85,000 /mo',
'Manage containerized cluster modules with Docker and Kubernetes while constructing decoupled, high-availability CI/CD pipelines.');

SELECT 
    jobs.title,
    jobs.job_type,
    jobs.location,
    jobs.salary,
    jobs.description,
    companies.company_name
FROM jobs
JOIN companies
ON jobs.company_id = companies.id;