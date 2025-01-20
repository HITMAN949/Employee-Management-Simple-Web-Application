const Department = require('../models/department');

const getAllDepartments = async (req, res) => {
    try {
        const departments = await Department.findAll();
        res.json(departments);
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
};

const getDepartmentById = async (req, res) => {
    const { id } = req.params;
    try {
        const department = await Department.findByPk(id);
        if (department) {
            res.json(department);
        } else {
            res.status(404).json({ error: 'Department not found' });
        }
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
};

const createDepartment = async (req, res) => {
    const { name, description } = req.body;
    try {
        const newDepartment = await Department.create({ name, description });
        res.status(201).json(newDepartment);
    } catch (err) {
        res.status(400).json({ error: err.message });
    }
};

const updateDepartment = async (req, res) => {
    const { id } = req.params;
    const { name, description } = req.body;
    try {
        const department = await Department.findByPk(id);
        if (department) {
            await department.update({ name, description });
            res.json({ message: 'Department updated successfully' });
        } else {
            res.status(404).json({ error: 'Department not found' });
        }
    } catch (err) {
        res.status(400).json({ error: err.message });
    }
};

const deleteDepartment = async (req, res) => {
    const { id } = req.params;
    try {
        const department = await Department.findByPk(id);
        if (department) {
            await department.destroy();
            res.json({ message: 'Department deleted successfully' });
        } else {
            res.status(404).json({ error: 'Department not found' });
        }
    } catch (err) {
        res.status(500).json({ error: err.message });
    }
};

module.exports = {
    getAllDepartments,
    getDepartmentById,
    createDepartment,
    updateDepartment,
    deleteDepartment
};
