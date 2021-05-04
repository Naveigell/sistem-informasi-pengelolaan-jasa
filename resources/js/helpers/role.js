const role = {
    setRole: (r) => {
        role.isAdmin = r === "admin";
        role.isTechnician = r === "teknisi";
        role.isUser = r === "user;"
    },
    isAdmin: false,
    isTechnician: false,
    isUser: false
};

export default role;
