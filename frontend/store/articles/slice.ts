import { createSlice, PayloadAction } from "@reduxjs/toolkit";
import { ArticleState, Article } from "./types";
import { PaginatedApiResponse } from "@/config/types/api";

const initialState: ArticleState = {
    articles: [],
    meta: {
        current_page: 1,
        per_page: 15,
        total: 0,
        last_page: 1,
    },
    loading: false,
};

const articleSlice = createSlice({
    name: "articles",
    initialState,
    reducers: {
        setArticlesAction(state, action: PayloadAction<PaginatedApiResponse<Article[]>>) {
            state.articles = action.payload.data;
            state.meta = action.payload.meta;
        },
        setLoading(state, action: PayloadAction<boolean>) {
            state.loading = action.payload;
        },
    },
});

export const { setArticlesAction, setLoading } = articleSlice.actions;
export default articleSlice.reducer;
