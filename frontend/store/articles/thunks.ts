import { getArticles } from "@/services/articles";
import { setArticles, setLoading } from "./slice";
import { ApiCallParams } from "@/config/types/api";

export const fetchArticles =
    ({ query, options }: ApiCallParams) =>
    async (dispatch: any) => {
        dispatch(setLoading(true));
        try {
            const res = await getArticles({
                query,
                options,
            });
            dispatch(setArticles(res.data));
        } catch (error) {
            console.error("Failed to fetch articles:", error);
        } finally {
            dispatch(setLoading(false));
        }
    };
