const role = {
    setRole: (r) => {
        role.isAdmin = r === "admin";
        role.isTechnician = r === "teknisi";
        role.isUser = r === "pelanggan"
    },
    isAdmin: false,
    isTechnician: false,
    isUser: false
};

export default role;
