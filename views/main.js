document.addEventListener('DOMContentLoaded', function() {
    fetchEmployees();

    const addEmployeeForm = document.getElementById('add-employee-form');
    addEmployeeForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(addEmployeeForm);
        const employee = {
            name: formData.get('name'),
            email: formData.get('email'),
            department_id: formData.get('department'),
            position: formData.get('position')
        };

        addEmployee(employee);
    });

    function fetchEmployees() {
        fetch('/api/employees')
            .then(response => response.json())
            .then(employees => {
                const employeeList = document.getElementById('employee-list');
                employeeList.innerHTML = '';
                employees.forEach(employee => {
                    const card = document.createElement('div');
                    card.classList.add('employee-card');
                    card.innerHTML = `
                        <h3>${employee.name}</h3>
                        <p>Email: ${employee.email}</p>
                        <p>Department: ${employee.department}</p>
                        <p>Position: ${employee.position}</p>
                        <button onclick="deleteEmployee(${employee.id})">Delete</button>
                    `;
                    employeeList.appendChild(card);
                });
            })
            .catch(error => console.error('Error fetching employees', error));
    }

    function addEmployee(employee) {
        fetch('/api/employees', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(employee)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to add employee');
            }
            return response.json();
        })
        .then(() => {
            fetchEmployees();
            addEmployeeForm.reset();
        })
        .catch(error => console.error('Error adding employee', error));
    }

    function deleteEmployee(employeeId) {
        fetch(`/api/employees/${employeeId}`, {
            method: 'DELETE'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to delete employee');
            }
            fetchEmployees();
        })
        .catch(error => console.error('Error deleting employee', error));
    }
});
