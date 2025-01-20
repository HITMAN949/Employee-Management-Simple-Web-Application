const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const { validationResult } = require('express-validator');
const User = require('../models/User');
const secretKey = process.env.SECRET_KEY;  // Ensure this is set in your environment variables

exports.login = async (req, res) => {
    const errors = validationResult(req);

    if (!errors.isEmpty()) {
        return res.status(400).json({ errors: errors.array() });
    }

    const { email, password } = req.body;

    try {
        let user = await User.findOne({ email });

        if (!user) {
            return res.status(404).json({ errors: [{ msg: 'Invalid credentials' }] });
        }

        const isMatch = await bcrypt.compare(password, user.password_hash);

        if (!isMatch) {
            return res.status(400).json({ errors: [{ msg: 'Invalid credentials' }] });
        }

        const payload = {
            user: {
                id: user.id,
                email: user.email,
                role: user.role
            }
        };

        jwt.sign(
            payload,
            secretKey,
            { expiresIn: '1h' },
            (err, token) => {
                if (err) throw err;
                res.json({ token });
            }
        );
    } catch (err) {
        console.error(err.message);
        res.status(500).send('Server Error');
    }
};

exports.authorizeHR = (req, res, next) => {
    const userRole = req.user.role;

    if (userRole !== 'HR Manager') {
        return res.status(401).json({ msg: 'Authorization denied' });
    }

    next();
};

