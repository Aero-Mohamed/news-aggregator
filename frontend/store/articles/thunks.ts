import { getArticles } from "@/services/articles";
import { setArticles, setLoading } from './slice';

export const fetchArticles = () => async (dispatch: any) => {
    dispatch(setLoading(true));
    try {
        const res = await getArticles({});
        dispatch(setArticles(res.data));
    } catch (error) {
        console.error("Failed to fetch articles:", error);
    } finally {
        dispatch(setLoading(false));
    }
};
