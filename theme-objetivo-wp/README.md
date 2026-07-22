# Tema WordPress — Objetivo São Carlos

Tema clássico (PHP) que reproduz o layout aprovado em [`../layout-apresentado/`](../layout-apresentado/)
como um site WordPress totalmente editável pelo admin, com o WooCommerce
gerenciando a aba **Shop** (excursões/eventos escolares).

**Não edite `layout-apresentado/`** — continua sendo a referência congelada.
Qualquer ajuste de layout/texto/imagem a partir de agora é feito aqui, no tema,
ou diretamente pelo wp-admin depois de instalado.

## Instalação

1. Copie a pasta `theme-objetivo-wp/` para `wp-content/themes/` do seu WordPress
   (ou instale como .zip pelo Aparência → Temas → Adicionar novo → Enviar tema).
2. Instale e **ative o plugin WooCommerce** antes de ativar este tema (ou logo
   em seguida — o seed de produtos roda automaticamente assim que o
   WooCommerce estiver ativo, mesmo que a ordem seja invertida).
3. Ative o tema **Objetivo São Carlos** em Aparência → Temas.
4. Na primeira ativação, o tema popula automaticamente (uma única vez):
   - os cards de Ensino, Motivos, Selos, Segmentos, Timeline e Vestibulares
     (com os mesmos textos/imagens do layout aprovado);
   - 8 posts de exemplo nas categorias Notícias/Eventos/Resultados;
   - as páginas **Nossa História** (modelo de timeline completa) e **Blog**
     (modelo de listagem paginada com filtro por categoria);
   - 3 produtos de exemplo na loja (Acampamento NR, Museu de Zoologia USP,
     Hopi Hari), com categoria "Excursões e Passeios" e os campos de
     "Detalhes do Evento" preenchidos;
   - o menu **Principal**, com a mesma estrutura de dropdowns do layout
     (itens sem página real apontam para `#` — edite o destino assim que
     criar a página correspondente);
   - os menus de rodapé **Rodapé — Ensino** e **Rodapé — Vestibulares**.

   Se o WooCommerce for ativado *depois* do tema, os produtos de exemplo não
   são criados automaticamente — nesse caso, cadastre-os manualmente em
   Produtos → Adicionar novo (a aba "Detalhes do Evento" já aparece no editor).

## Editando o conteúdo (sem programar)

| O que editar | Onde |
|---|---|
| Cards de Ensino, Motivos, Selos, Segmentos, Timeline, Vestibulares | Menus próprios no admin (ex.: "Sistema de Ensino", "Motivos para Estudar" etc.) — cada item tem título, descrição, imagem e campos extras próprios. A ordem é definida pelo campo "Ordem" (Atributos de página) de cada item. |
| Notícias / Blog | Posts nativos do WordPress, nas categorias Notícias, Eventos e Resultados |
| Textos fixos (hero, estatísticas, textos de cada seção, rodapé, contato) | Aparência → Personalizar → painel **"Conteúdo do site Objetivo"** |
| Menus (cabeçalho, rodapé) | Aparência → Menus |
| Logo | Aparência → Personalizar → Identidade do Site (ou fica com o logo padrão do tema) |
| Produtos/excursões da loja | Produtos (WooCommerce) → aba "Detalhes do Evento" para data/local/vagas |

## WooCommerce — configuração recomendada

- **Exigir login para comprar** (equivalente ao login por RA do protótipo):
  WooCommerce → Configurações → Contas e Privacidade → desmarque "Permitir
  finalização de compra como visitante".
- **Gateway de pagamento**: configure em WooCommerce → Configurações →
  Pagamentos (Pix, cartão via Mercado Pago/PagSeguro/Stripe, etc.). O tema
  não processa pagamento diretamente — usa o carrinho/checkout nativo do
  WooCommerce, só restilizado com as cores da marca.
- O card de produto na loja usa a imagem destacada, o campo "Data do evento"
  (aba "Detalhes do Evento") e o preço; o botão "Comprar" é o
  add-to-cart real do WooCommerce (funciona com AJAX).

## Estrutura do tema

```
inc/setup.php         Theme supports, locais de menu, widget area, enqueue de assets
inc/meta-boxes.php     Helper genérico de meta box (usado pelos 6 CPTs)
inc/cpt.php            Registro dos 6 Custom Post Types de conteúdo repetível
inc/customizer.php     Todos os textos/imagens globais, via Personalizar
inc/woocommerce.php    Suporte ao WooCommerce + aba "Detalhes do Evento"
inc/activation.php     Seed de conteúdo padrão (roda uma vez, no init após ativar)
template-parts/front/  Uma seção da home por arquivo (hero, stats, ensino, ...)
woocommerce/           Overrides de archive-product.php e content-product.php
assets/                CSS/JS/imagens do tema
```

## Fora do escopo deste tema

- Gateway de pagamento real (depende de plugin/configuração do WooCommerce).
- `screenshot.png` do tema (adicione um print do site em Aparência → Temas
  depois de configurado, salvando como `screenshot.png` na raiz do tema).
- Conteúdo das páginas institucionais que ainda são links `#` no menu
  (Proposta Pedagógica, Convênios, Dados Institucionais etc.) — crie essas
  páginas em Páginas → Adicionar nova (usam o modelo padrão, com banner de
  título automático) e depois edite o link correspondente em Aparência → Menus.
