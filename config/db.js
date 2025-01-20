const { Sequelize } = require('sequelize');

const dialect = 'mysql';  
const username = 'myuser';
const password = 'mypassword';
const host = 'localhost';
const port = 3306;
const dbName = 'employee_management';

const sequelize = new Sequelize(dbName, username, password, {
  host: host,
  port: port,
  dialect: dialect,
  dialectOptions: {
    
  },
  define: {
    timestamps: true,
    underscored: true,
    
  },
});

async function testConnection() {
  try {
    await sequelize.authenticate();
    console.log('Database connection has been established successfully.');
  } catch (error) {
    console.error('Unable to connect to the database:', error);
  }
}

testConnection();

module.exports = sequelize;
