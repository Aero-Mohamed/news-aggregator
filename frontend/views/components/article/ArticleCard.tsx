import { Card } from "@/components/ui/card";

export default function ArticleCard({ article }: { article: any }) {
    return (
        <Card className="p-4">
            <h2 className="text-lg font-semibold">{article.title}</h2>
            <p className="text-sm text-muted-foreground line-clamp-3">{article.description}</p>
            <a href={article.url} target="_blank" className="text-sm text-blue-600 mt-2 block">
                Read more →
            </a>
        </Card>
    );
}
