const validateEmail = (email) => {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
};

const validatePhone = (phone) => {
    const re = /^\d{10,}$/;
    return re.test(String(phone));
};

export { validateEmail, validatePhone };
