const Employee = require('../models/Employee');


exports.getAllEmployees = async (req, res) => {
  try {
    const employees = await Employee.findAll();
    res.json(employees);
  } catch (error) {
    console.error('Error fetching employees:', error);
    res.status(500).json({ error: 'Failed to fetch employees' });
  }
};


exports.getEmployeeById = async (req, res) => {
  const { id } = req.params;
  try {
    const employee = await Employee.findByPk(id);
    if (!employee) {
      return res.status(404).json({ error: 'Employee not found' });
    }
    res.json(employee);
  } catch (error) {
    console.error('Error fetching employee:', error);
    res.status(500).json({ error: 'Failed to fetch employee' });
  }
};


exports.createEmployee = async (req, res) => {
  const { name, dateOfBirth, age, city, idCard, email, department, position, department_id } = req.body;
  try {
    const newEmployee = await Employee.create({
      name,
      dateOfBirth,
      age,
      city,
      idCard,
      email,
      department,
      position,
      department_id,
    });
    res.status(201).json(newEmployee);
  } catch (error) {
    console.error('Error creating employee:', error);
    res.status(500).json({ error: 'Failed to create employee' });
  }
};


exports.updateEmployee = async (req, res) => {
  const { id } = req.params;
  const { name, dateOfBirth, age, city, idCard, email, department, position, department_id } = req.body;
  try {
    const employee = await Employee.findByPk(id);
    if (!employee) {
      return res.status(404).json({ error: 'Employee not found' });
    }
    employee.name = name;
    employee.dateOfBirth = dateOfBirth;
    employee.age = age;
    employee.city = city;
    employee.idCard = idCard;
    employee.email = email;
    employee.department = department;
    employee.position = position;
    employee.department_id = department_id;
    await employee.save();
    res.json(employee);
  } catch (error) {
    console.error('Error updating employee:', error);
    res.status(500).json({ error: 'Failed to update employee' });
  }
};


exports.deleteEmployee = async (req, res) => {
  const { id } = req.params;
  try {
    const employee = await Employee.findByPk(id);
    if (!employee) {
      return res.status(404).json({ error: 'Employee not found' });
    }
    await employee.destroy();
    res.json({ message: 'Employee deleted successfully' });
  } catch (error) {
    console.error('Error deleting employee:', error);
    res.status(500).json({ error: 'Failed to delete employee' });
  }
};
