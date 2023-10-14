# Introduction

Advanced company management backend application in progress. <br />
What can you except:
- Authentication and Role-Based Access Control: 
Secure your data with advanced authentication protocols. 
Define roles such as administrators, project managers, and employees, 
ensuring data access is restricted to authorized personnel only.
- Password Resets and Email Notifications: Simplify security management with user-friendly password reset features. Receive timely email notifications for crucial actions, keeping you informed about project milestones and task completions.
- Client, Project, and Task Management: Streamline your 
workflow by creating clients, projects, and tasks seamlessly. 
Organize intricate projects into manageable tasks
- Employee Assignment and Time Tracking: Efficiently assign tasks 
to specific employees monitor their working hours accurately. 
Stay updated on project progress, deadlines, and resource allocation in real-time.
- Project and Task Status Updates: Receive instant updates on project 
and task statuses.
- PDF Generation and Invoicing:
Create detailed invoices tailored to your client’s needs, enhancing your company's professionalism and efficiency.

# Installation

Please make sure to not miss any step along the process.

1. Clone the project <br />
   ``` git clone https://github.com/ealili/inventorx-backend.git```


2. Change current directory to project's directory <br />
   ``` cd inventorx-backend```


3. Copy *.example.env* to a *.env* file
    - For Windows <br />
      ``` copy .env.example .env```

    - For Linux or macOS <br />
      ``` cp .env.example .env```


4. According to your configuration, fill out the empty environment variables found in the **.env** file.


5. Install the required dependencies by running
   ```composer install```


6. Generate an application key <br />
   ```php artisan key:generate```


7. Run the database migrations <br />
   ``` php artisan:migrate```


8. Run database seeders <br />
   ``` php artisan:db:seed```


10. Lastly, run the project <br />
    ```php artisan serve```
 
