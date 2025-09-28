# 家計簿アプリ (Money App)

Spring Boot + Next.js を用いた家計簿アプリです。  
収支の記録・グラフ表示・ラベル管理・アラートメール通知機能などができます。  
[デモURLはこちら](https://money-app-frontend-six.vercel.app/)

---

## 機能
- 収支登録（支出・収入）
- ラベル管理
- 月ごとの合計・グラフ表示
- 日ごとの合計・グラフ表示
- メール通知機能(使いすぎ抑制アラート)
- ユーザー認証 (JWT)

---

## 技術スタック
### フロントエンド
- Next.js (App Router)
- Tailwind CSS
- Chart.js (グラフ表示)

### バックエンド
- Spring Boot (Gradle)
- Spring Security + JWT
- MySQL(開発環境)、Postgres(本番環境)

---

## デプロイ環境

- **フロントエンド**: Next.js + Tailwind CSS (Vercelにデプロイ)
- **バックエンド**: Spring Boot (Renderにデプロイ)
- **DB**: PostgreSQL (SupaBaseのPostgreSQL)

GitHub Actions を使い、push 時に自動デプロイする構成。
将来的には AWS ECS  + API Gateway + RDS への移行も検討中。

---

## 各リポジトリ
- フロントエンド：https://github.com/usatai/money-app-frontend
- バックエンド：https://github.com/usatai/money-app-backend
