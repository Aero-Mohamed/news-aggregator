import { createSlice, PayloadAction } from "@reduxjs/toolkit";
import { AuthState, AuthUserRes } from "./types";
import { ApiResponse } from "@/config/types/api";
import Cookies from "js-cookie";

const initialState: AuthState = {
    user: { id: 0, name: "", email: "" },
    isAuthenticated: false,
    loading: false,
};

const authSlice = createSlice({
    name: "auth",
    initialState,
    reducers: {
        hydrateAuthFromStorage(state, action: PayloadAction<AuthState>) {
            state.user = action.payload.user;
            state.isAuthenticated = action.payload.isAuthenticated;
        },
        // for login or register actions
        authenticateAction(state, action: PayloadAction<ApiResponse<AuthUserRes>>): void {
            state.user = {
                id: action.payload.data?.id,
                name: action.payload.data.name,
                email: action.payload.data.email,
            };
            state.isAuthenticated = true;

            localStorage.setItem("user", JSON.stringify(state.user));

            if (typeof document !== "undefined") {
                const access_token: string = action.payload.data.access_token;
                const expires_in: number = action.payload.data.expires_in;
                Cookies.set("token", access_token, {
                    expires: expires_in,
                });
            }
        },
        logoutAction(state, action: PayloadAction<ApiResponse<null>>): void {
            state.user = {
                id: 0,
                name: "",
                email: "",
            };
            state.isAuthenticated = false;

            if (typeof document !== "undefined") {
                Cookies.remove("token");
            }

            if (typeof window !== "undefined") {
                localStorage.removeItem("user");
            }
        },
        setLoading(state, action: PayloadAction<boolean>): void {
            state.loading = action.payload;
        },
    },
});

export const { hydrateAuthFromStorage, authenticateAction, logoutAction, setLoading } =
    authSlice.actions;
export default authSlice.reducer;
