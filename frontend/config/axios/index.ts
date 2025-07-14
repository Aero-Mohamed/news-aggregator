import axios from "axios";
import vars from "@/utils/vars";
import { toast } from "sonner";

const config = { baseURL: vars.app.baseUrl || "", headers: { ...(vars.api.headers || {}) } };
const axiosInstance = axios.create(config);

// Global error handling with toast
axiosInstance.interceptors.response.use(
    response => response,
    error => {
        const message = error?.response?.data?.message || error?.message || "Something went wrong";

        if (typeof window !== "undefined") {
            toast.error(message);
        }

        return Promise.reject(error);
    }
);

export default axiosInstance;
