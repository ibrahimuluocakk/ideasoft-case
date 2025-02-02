# E-commerce Case 

Bu proje, e-ticaret sisteminde sipariş ve indirim yönetimini içeren bir RESTful API uygulamasıdır.

## Proje Hakkında

Bu case study, e-ticaret sistemlerinde sıkça karşılaşılan sipariş ve indirim senaryolarını ele almaktadır. Proje kapsamında:

- Kullanıcı yönetimi (kayıt ve giriş)
- Kategori ve ürün yönetimi
- Sipariş oluşturma ve listeleme
- Dinamik indirim hesaplama

özellikleri bulunmaktadır.

## Teknolojiler

- PHP 8.2
- Laravel 11.x
- MySQL 8.0
- Nginx
- Docker & Docker Compose

## Gereksinimler

- Docker
- Docker Compose
- Make (opsiyonel)

## Kurulum

## Projeyi klonlayın
- git clone git@github.com:ibrahimuluocakk/ideasoft-case.git
- cd ideasoft-case
- Ortam değişkenlerini ayarlayın
- cp .env.example .env

### Make ile Kurulum

- make init

### Manuel Kurulum

- docker-compose up -d --build

## Proje Yapısı

- Port: 8000 (http://localhost:8000)
- Database Port: 3306
- API Prefix: /api

## İndirim Sistemi

Proje kapsamında 3 farklı indirim kuralı bulunmaktadır:

1. Toplam Tutar İndirimi: 1000TL ve üzeri alışverişlerde %10 indirim
2. Kategori Bazlı Bulk İndirim: 2. kategoriden 6 adet alındığında 1 tanesi bedava
3. Kategori Bazlı Çoklu Alım İndirimi: 1. kategoriden 2+ ürün alındığında en ucuza %20 indirim

İndirimler öncelik sırasına göre uygulanır ve kümülatif olarak hesaplanır.

## Veritabanı Yapısı

Proje 5 ana tabloya sahiptir:
- categories: Kategoriler
- products: Ürünler
- orders: Siparişler
- order_items: Siparişlere ait ürünler
- discount_rules: İndirim kuralları

## Geliştirme Ortamı

Proje Docker üzerinde çalışmaktadır ve aşağıdaki servislerden oluşur:
- PHP-FPM (app)
- Nginx (web server)
- MySQL (database)

## Notlar

- Tüm API istekleri için Bearer token authentication gereklidir
- Veritabanı otomatik olarak migrate edilir kategoriler, ürünler, indirim kuralları eklenir. Dilerseniz kendiniz de ekleyebilirsiniz.
- API dokümantasyonu için : https://documenter.getpostman.com/view/36970650/2sAYX3riMW

