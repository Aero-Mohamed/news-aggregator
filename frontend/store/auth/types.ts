export interface User {
    id: number;
    name: string;
    email: string;
}

export interface AuthUserRes extends User {
    access_token: string;
    expires_in: number;
}

export interface AuthState {
    user: User;
    isAuthenticated: boolean;
    loading: boolean;
}
