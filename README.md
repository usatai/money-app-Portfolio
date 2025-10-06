# 💰 Money App - 家計簿アプリ



**Spring Boot + Next.js で開発したモダンな家計簿アプリケーションです。**

日々の収支を手軽に記録し、グラフで可視化することで、直感的な資産管理を実現します。
使いすぎを防止するアラートメール機能も搭載し、計画的な家計管理をサポートします。

**デモサイトへのリンクはこちら**
> **Demo URL:** 【https://money-app-frontend-six.vercel.app/】
>
> 右上のゲストログインでログインください
---

## ✨ 機能一覧 (Features)

以下が主要な機能です。

-   **✍️ 収支登録:** シンプルなUIで日々の支出・収入を素早く記録
-   **🏷️ ラベル管理:** 「食費」「交通費」など自由にカテゴリを分けて管理
-   **📊 グラフ分析:** 月別・日別の収支をグラフで可視化し、家計の状況を直感的に把握
-   **📧 アラートメール:** 設定した予算を超えるとメールで通知し、使いすぎを防止
-   **🔐 ユーザー認証:** JWT (JSON Web Token) を用いたセキュアな認証機能

---

## 🛠️ 技術スタック (Tech Stack)

モダンでスケーラブルな技術を選定しました。

#### フロントエンド
![Next.js](https://img.shields.io/badge/Next.js-000000?style=for-the-badge&logo=next.js&logoColor=white)
![React](https://img.shields.io/badge/React-20232A?style=for-the-badge&logo=react&logoColor=61DAFB)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Chart.js](https://img.shields.io/badge/Chart.js-FF6384?style=for-the-badge&logo=chart.js&logoColor=white)

#### バックエンド
![Spring](https://img.shields.io/badge/Spring-6DB33F?style=for-the-badge&logo=spring&logoColor=white)
![Java](https://img.shields.io/badge/Java-ED8B00?style=for-the-badge&logo=java&logoColor=white)
![Gradle](https://img.shields.io/badge/Gradle-02303A?style=for-the-badge&logo=gradle&logoColor=white)
![Spring Security](https://img.shields.io/badge/Spring_Security-6DB33F?style=for-the-badge&logo=spring-security&logoColor=white)
![JWT](https://img.shields.io/badge/JWT-000000?style=for-the-badge&logo=json-web-tokens&logoColor=white)

#### データベース
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

---

## 🚀 インフラ・CI/CD (Infrastructure)

構成図
<img width="383" height="418" alt="スクリーンショット 0007-10-06 22 19 40" src="https://github.com/user-attachments/assets/be823a0c-4e52-42aa-91a1-daadb6f7fc22" />


[Image of App infrastructure diagram]

*(可能なら構成図を入れるとプロっぽさが格段に上がります)*

自動デプロイの仕組みを構築し、開発体験の向上を意識しました。

-   **Frontend:** Vercel
-   **Backend:** Render
-   **Database:** Supabase (PostgreSQL)
-   **CI/CD:** GitHub Actions
    -   `main`ブランチへのpushをトリガーに、Vercel (FE) と Render (BE) へ自動でデプロイが実行されます。
-   **今後の展望:** ユーザー増加を想定し、さらなるスケーラビリティと可用性を求め、AWS (ECS, API Gateway, RDS) への移行を検討しています。

---

## 💡 こだわった点・学んだこと (Challenges & Learnings)

このアプリ開発を通じて、特に以下の点に注力し、多くの学びを得ました。

-   **例1：パフォーマンス改善**
    > グラフ表示機能で当初パフォーマンスの低下が見られましたが、バックエンドのクエリを見直し、N+1問題を解決することで表示速度を〇〇秒改善しました。

-   **例2：UI/UXの工夫**
    > ユーザーが毎日使うアプリであることを意識し、Tailwind CSSを用いて直感的でストレスのないUIデザインを追求しました。特に入力フォームのバリデーションは、リアルタイムでフィードバックを返すことでUXを向上させました。

-   **例3：インフラ構築**
    > 初めてGitHub Actionsを用いたCI/CDパイプラインの構築に挑戦しました。環境変数の管理やデプロイフローの自動化で多くのエラーに直面しましたが、公式ドキュメントを読み解き、無事に自動化を実現できました。

---

## 📂 各リポジトリ (Repositories)

-   **Frontend:** [usatai/money-app-frontend](https://github.com/usatai/money-app-frontend)
-   **Backend:** [usatai/money-app-backend](https://github.com/usatai/money-app-backend)
