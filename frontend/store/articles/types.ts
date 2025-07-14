import {Meta} from "@/config/types/api";

export interface Source {
    id: string;
    name: string;
}

export interface Author {
    id: string;
    name: string;
}

export interface Category {
    id: string;
    name: string;
}

export interface Article {
    id: string;
    title: string;
    slug: string;
    description: string | null;
    content: string;
    image_url: string;
    url: string;
    published_at: string;
    source: Source;
    authors: Author[];
    categories: Category[];
}

// Redux state interface
export interface ArticleState {
    articles: Article[];
    meta: Meta|null;
    loading: boolean;
}
