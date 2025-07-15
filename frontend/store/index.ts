import { configureStore } from "@reduxjs/toolkit";
import articlesReducer from "./articles/slice";
import authReducer from "./auth/slice";
import uiReducer from "./ui/slice";

export const store = configureStore({
    reducer: {
        ui: uiReducer,
        articles: articlesReducer,
        auth: authReducer,
    },
});

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;
