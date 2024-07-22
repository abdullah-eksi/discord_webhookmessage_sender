
# Discord Webhook Yöneticisi

Bu proje, PHP tabanlı bir web arayüzü kullanarak Discord webhooklarını yönetmenizi ve mesaj göndermenizi sağlar. Webhook ekleyebilir, mesaj gönderebilir ve mevcut webhookları silebilirsiniz.

## Özellikler

- Yeni Discord webhookları ekleme
- Mevcut webhooklara mesaj gönderme
- Webhook silme

## Kurulum

1. **Depoyu klonlayın:**

   ```sh
   git clone https://github.com/kullaniciadi/discord-webhook-yoneticisi.git
   ```

2. **Proje dizinini web sunucusuna yerleştirip çalıştırın :**

   ```sh
   cd discord-webhook-yoneticisi
   ```

## Kullanım

1. **Webhook Ekleme:**

   - "Webhook Ekle" formunu doldurun ve "Ekle" butonuna basın.

2. **Mesaj Gönderme:**

   - "Webhook'a Mesaj Gönder" formundan bir webhook seçin.
   - Mesajınızı yazın ve "Gönder" butonuna basın.

3. **Webhook Silme:**

   - "Webhook'a Mesaj Gönder" formundan silmek istediğiniz webhooku seçin.
   - "Sil" butonuna basın.

## işleyiş

### session_start() ve ob_start()

- **session_start()**: PHP oturumunu başlatır, verileri oturumda saklamamızı sağlar.
- **ob_start()**: Çıkış tamponlamasını başlatır, bu sayede çıktı verilerini tamponda tutabiliriz.

### Webhook Ekleme

- Kullanıcıdan alınan webhook adı ve URL'si ile rastgele bir ID oluşturulur.
- Bu bilgiler bir diziye eklenir ve oturumda saklanır.

### Mesaj Gönderme

- Kullanıcıdan seçilen webhook ID'sine göre ilgili webhook bulunur.
- Kullanıcının girdiği mesaj, seçilen webhook URL'sine JSON formatında gönderilir.

### Webhook Silme

- Kullanıcıdan seçilen webhook ID'sine göre ilgili webhook bulunur ve oturumdan silinir.

## Lisans

Bu proje MIT lisansı ile lisanslanmıştır. Daha fazla bilgi için `LICENSE` dosyasına bakın.


