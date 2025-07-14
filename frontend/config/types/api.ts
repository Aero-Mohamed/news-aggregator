
export interface Meta {
    current_page: number;
    per_page: number;
    total: number;
    last_page: number;
}

export interface ApiResponse<T> {
    data: T;
    errors: null|string[];
    message: null|string;
    status_code: number;
    success: boolean;
}

export interface PaginatedApiResponse<T> extends ApiResponse<T> {
    meta: Meta;
}
