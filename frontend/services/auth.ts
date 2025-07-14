import axios from "@/config/axios";
import { AxiosResponse } from "axios";
import { PostApiCallParams, PaginatedApiResponse } from "@/config/types/api";
import { AuthUserRes } from "@/store/auth/types";

type AuthApiResponse = Promise<AxiosResponse<PaginatedApiResponse<AuthUserRes>>>;

export const postLogin = ({ data = {}, options = {} }: PostApiCallParams = {}): AuthApiResponse => {
    return axios.post(`/auth/login`, data, options);
};
