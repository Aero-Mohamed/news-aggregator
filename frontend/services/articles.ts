import axios from "@/config/axios";
import { AxiosResponse } from "axios";
import { ApiCallParams, PaginatedApiResponse } from "@/config/types/api";
import { Article } from "@/store/articles/types";

type GetArticleApiResponse = Promise<AxiosResponse<PaginatedApiResponse<Article[]>>>;

export const getArticles = ({
    query = {},
    options = {},
}: ApiCallParams = {}): GetArticleApiResponse => {
    return axios.get(`/articles`, {
        ...options,
        params: query,
    });
};
