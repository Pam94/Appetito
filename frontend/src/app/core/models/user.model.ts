export class User {
    name!: string;
    surname!: string;
    email!: string;
    password!: string;
    rememberToken!: boolean;
}

export class UserRegister {
    name!: string;
    surname!: string;
    email!: string;
    password!: string;
    repeatPassword!: string;
}

export class UserLogin {
    email!: string;
    password!: string;
    rememberToken!: boolean;
}
