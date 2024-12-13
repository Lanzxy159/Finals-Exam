CREATE TABLE HR (
    hr_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255),
    password VARCHAR(255),
    name VARCHAR(100) NOT NULL,
    position VARCHAR(50)
);

-- APPLICANT table
CREATE TABLE APPLICANT (
    applicant_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255),
    password VARCHAR(255),
    name VARCHAR(100) NOT NULL,
    resume TEXT,
);

-- MESSAGES table
CREATE TABLE MESSAGES (
    message_id INT PRIMARY KEY AUTO_INCREMENT,
    applicant_id INT,
    hr_id INT,
    message_content TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- JOB POST table
CREATE TABLE JOB_POST (
    job_post_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    position VARCHAR(255),
    description TEXT,
    location VARCHAR(100),
    salary_range VARCHAR(50),
    hr_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Status Applicants
CREATE TABLE Job_applicants (
    Job_applicants INT PRIMARY KEY AUTO_INCREMENT,
    applicant_id int not NULL,
    title INT NOT NULL,
    job_post_id INT NOT NULL,                        
    hr_id INT NOT NULL,                              
    status VARCHAR(255) DEFAULT 'Pending', 
    application_message TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
