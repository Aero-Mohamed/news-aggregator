import { postLogin, postLogout, postRegister } from "@/services/auth";
import { authenticateAction, logoutAction, setLoading } from "./slice";
import { setLoading as setUiLoading } from "../ui/slice";
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
            dispatch(authenticateAction(res.data));
        } catch (error) {
            throw error;
        } finally {
            dispatch(setLoading(false));
        }
    };

export const userRegister =
    ({ data, options }: PostApiCallParams) =>
    async (dispatch: any) => {
        dispatch(setLoading(true));
        try {
            const res = await postRegister({
                data,
                options,
            });
            dispatch(authenticateAction(res.data));
        } catch (error) {
            throw error;
        } finally {
            dispatch(setLoading(false));
        }
    };

export const userLogout = () => async (dispatch: any) => {
    dispatch(setUiLoading(true));
    try {
        const res = await postLogout();
        dispatch(logoutAction(res.data));
    } catch (error) {
        throw error;
    } finally {
        dispatch(setUiLoading(false));
    }
};
