const { DataTypes } = require('sequelize');
const sequelize = require('../config/db');

const Employee = sequelize.define('Employee', {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true
  },
  last_name: {
    type: DataTypes.STRING(255),
    allowNull: true
  },
  first_name: {
    type: DataTypes.STRING(255),
    allowNull: true
  },
  date_of_birth: {
    type: DataTypes.DATE,
    allowNull: false
  },
  age: {
    type: DataTypes.INTEGER,
    allowNull: false
  },
  city_of_birth: {
    type: DataTypes.STRING(255),
    allowNull: false
  },
  cin: {
    type: DataTypes.STRING(255),
    allowNull: false,
    unique: true
  },
  email: {
    type: DataTypes.STRING(255),
    allowNull: false
  },
  department: {
    type: DataTypes.STRING(255),
    allowNull: true
  },
  position: {
    type: DataTypes.STRING(255),
    allowNull: true
  },
  department_id: {
    type: DataTypes.INTEGER,
    allowNull: true,
    references: {
      model: 'Departments',
      key: 'id'
    }
  },
  site: {
    type: DataTypes.STRING(255),
    allowNull: true
  },
  sous_site: {
    type: DataTypes.STRING(255),
    allowNull: true
  },
  createdAt: {
    type: DataTypes.DATE,
    allowNull: true
  },
  updatedAt: {
    type: DataTypes.DATE,
    allowNull: true
  }
}, {
  tableName: 'employees',
  timestamps: true,
  underscored: true
});

module.exports = Employee;
