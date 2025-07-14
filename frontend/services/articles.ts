import axios from "@/config/axios";
import { AxiosRequestConfig, AxiosResponse } from "axios";
import { PaginatedApiResponse } from "@/config/types/api";
import { Article } from "@/store/articles/types";

interface GetArticlesParams {
    query?: Record<string, any>;
    options?: AxiosRequestConfig;
}

type GetArticleApiResponse = Promise<AxiosResponse<PaginatedApiResponse<Article[]>>>;

export const getArticles = ({
    query = {},
    options = {},
}: GetArticlesParams = {}): GetArticleApiResponse => {
    return axios.get(`/articles`, {
        ...options,
        params: query,
    });
};
