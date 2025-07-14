import { createSlice, PayloadAction } from "@reduxjs/toolkit";
import { ArticleState, Article } from "./types";
import { PaginatedApiResponse } from "@/config/types/api";

const initialState: ArticleState = {
    articles: [],
    meta: null,
    loading: false,
};

const articleSlice = createSlice({
    name: "articles",
    initialState,
    reducers: {
        setArticles(state, action: PayloadAction<PaginatedApiResponse<Article[]>>) {
            state.articles = action.payload.data;
            state.meta = action.payload.meta;
        },
        setLoading(state, action: PayloadAction<boolean>) {
            state.loading = action.payload;
        },
    },
});

export const { setArticles, setLoading } = articleSlice.actions;
export default articleSlice.reducer;
