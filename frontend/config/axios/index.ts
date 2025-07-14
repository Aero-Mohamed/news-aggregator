import axios from "axios";
import vars from "@/utils/vars";
import { toast } from "sonner";
import Cookies from "js-cookie";

const config = { baseURL: vars.app.baseUrl || "", headers: { ...(vars.api.headers || {}) } };
const axiosInstance = axios.create(config);

// Attach token from localStorage before each request
axiosInstance.interceptors.request.use(
    config => {
        if (typeof window !== "undefined") {
            const token = Cookies.get("token");
            if (token) {
                config.headers["Authorization"] = `Bearer ${token}`;
            }
        }
        return config;
    },
    error => Promise.reject(error)
);

// Global error handling with toast
axiosInstance.interceptors.response.use(
    response => {
        const message = response?.data?.message;
        if (message && typeof window !== "undefined") {
            toast.success(message);
        }
        return response;
    },
    error => {
        const message = error?.response?.data?.message || error?.message || "Something went wrong";

        if (typeof window !== "undefined") {
            toast.error(message);
        }

        return Promise.reject(error);
    }
);

export default axiosInstance;
