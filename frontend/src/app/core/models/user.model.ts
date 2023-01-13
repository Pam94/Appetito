export interface User {
    name: string;
    surname: string;
    email: string;
    password: string;
}

export interface UserRegister {
    name: string;
    surname: string;
    email: string;
    password: string;
    repeatPassword: string;
}

export interface UserLogin {
    email: string;
    password: string;
}
