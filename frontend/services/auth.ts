import axios from "@/config/axios";
import { AxiosResponse } from "axios";
import { PostApiCallParams, PaginatedApiResponse, ApiResponse } from "@/config/types/api";
import { AuthUserRes } from "@/store/auth/types";

type AuthApiResponse = Promise<AxiosResponse<PaginatedApiResponse<AuthUserRes>>>;
type LogoutApiResponse = Promise<AxiosResponse<ApiResponse<null>>>;

export const postLogin = ({ data = {}, options = {} }: PostApiCallParams = {}): AuthApiResponse => {
    return axios.post(`/auth/login`, data, options);
};

export const postRegister = ({
    data = {},
    options = {},
}: PostApiCallParams = {}): AuthApiResponse => {
    return axios.post(`/auth/register`, data, options);
};

export const postLogout = (): LogoutApiResponse => {
    return axios.post(`/auth/logout`);
};
