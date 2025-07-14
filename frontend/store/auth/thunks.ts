import { postLogin } from "@/services/auth";
import { login, setLoading } from "./slice";
import { PostApiCallParams } from "@/config/types/api";

export const authenticate =
    ({ data, options }: PostApiCallParams) =>
    async (dispatch: any) => {
        dispatch(setLoading(true));
        try {
            const res = await postLogin({
                data,
                options,
            });
            dispatch(login(res.data));
        } catch (error) {
            throw error;
        } finally {
            dispatch(setLoading(false));
        }
    };
