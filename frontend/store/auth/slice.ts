import { createSlice, PayloadAction } from "@reduxjs/toolkit";
import { AuthState, AuthUserRes } from "./types";
import { ApiResponse } from "@/config/types/api";
import axiosInstance from "@/config/axios";

const initialState: AuthState = {
    user: {
        id: 0,
        name: "",
        email: "",
    },
    isAuthenticated: false,
    loading: false,
};

const authSlice = createSlice({
    name: "auth",
    initialState,
    reducers: {
        login(state, action: PayloadAction<ApiResponse<AuthUserRes>>) {
            state.user = {
                id: action.payload.data?.id,
                name: action.payload.data.name,
                email: action.payload.data.email,
            };
            state.isAuthenticated = true;

            if (typeof document !== "undefined") {
                const access_token: string = action.payload.data.access_token;
                const expires_in: number = action.payload.data.expires_in;
                document.cookie = `token=${access_token}; path=/; max-age=${expires_in}; secure; samesite=strict`;
            }
        },
        setLoading(state, action: PayloadAction<boolean>) {
            state.loading = action.payload;
        },
    },
});

export const { login, setLoading } = authSlice.actions;
export default authSlice.reducer;
