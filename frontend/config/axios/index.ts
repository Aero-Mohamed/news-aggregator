import axios from "axios";
import vars from "@/utils/vars";

const config = { baseURL: vars.app.baseUrl || "", headers: { ...(vars.api.headers || {}) } };
const axiosInstance = axios.create(config);

export default axiosInstance;
