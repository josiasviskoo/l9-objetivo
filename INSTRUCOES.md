# Estrutura do projeto

Este repositório contém o layout de referência do site do Colégio/Cursinho Objetivo (São Carlos) e o plugin WordPress que será construído a partir dele.

## `layout-apresentado/`

Layout estático (HTML/CSS/imagens) **já apresentado ao cliente e aprovado**. É a referência visual e de conteúdo para o plugin WordPress.

**Regra: não editar nada dentro desta pasta.** Ela é congelada como projeto de referência — qualquer ajuste de layout, texto ou imagem deve ser feito diretamente no plugin WordPress (`plugin-wp/`), nunca aqui. Se for necessário comparar "como era" vs "como ficou", este é o ponto de partida imutável.

Conteúdo:
- `index.html` — página principal (home, segmentos, timeline, blog).
- `index_backup.html` — backup de uma versão anterior da home.
- `shop.html` — página de excursões/passeios ("Shop Objetivo").
- `logo_objetivo_azul.png`, `logo_objetivo_branco.png` — variações do logo.
- `logos/` — logos e selos adicionais (ENEM, anos consecutivos, etc.).
- `assets/img/` — imagens usadas nas seções (acampamento, Hopi Hari, museu de zoologia, etc.).

## `plugin-wp/`

Pasta onde será desenvolvido o **plugin WordPress** que recria o layout de `layout-apresentado/` como um tema/plugin dinâmico (com blocos, custom post types, etc. conforme necessário). Todo o desenvolvimento novo acontece aqui.
