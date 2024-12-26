# LEMP構成のPHP開発環境を構築

Vagrantコマンドの実行でVirtualBoxベースの仮想環境(Ubuntu22)上にLEMP環境を構築します。
LEMP環境に対してVSCodeでリモートデバッグができます。

LEMP環境は最新のバージョンがインストールされます。

- PHP 8.4
- Nginx 1.18
- MariaDB 11.7

![lemp-dev](https://github.com/user-attachments/assets/f20ecdfc-579b-4f58-9b93-42be632340b7)

## インストールに必要な環境

- Windows 11
- Visual Studio Code
- Vagrant実行環境

## LEMP環境の構築

1. `Vagrantfile`を編集します。仮想サーバに**SSH公開鍵認証**で接続できるように**IP**と**SSH接続**を設定します。

```
# Network
config.vm.network "private_network", ip: "192.168.33.10"

...
# SSH configuration for the VM
config.vm.provision "shell" do |sh|
  # Local SSH public key
  ssh_pub_key = File.readlines("#{Dir.home}/.ssh/id_rsa.pub").first.strip

  ...
end
```

2. Vagrantコマンドを実行します。

```
vagrant up
```

3. 環境構築完了するとWebサーバにアクセスできます。

```
http://192.168.33.10
```

## サンプルスクリプト

2つのPHPスクリプトが実行できます。

- index.php - phpinfo()を表示します
- index2.php - DBに登録したデータを表示します

以下のURLでアクセスできます。

```
http://192.168.33.10/
http://192.168.33.10/index2.php
```

## phpMyAdmin

**phpMyAdmin**は8080ポートで使用できます。

```
http://192.168.33.10:8080
```

## デバッグ

1. VSCodeの**リモートエクスプローラ**から**トンネル機能**を使用して仮想サーバにSSH接続します。開くフォルダパスは`/var/www/remote`です。
2. **PHP Debug**のインストールを提案されるので、ボタンを押して仮想サーバにインストールします。
3. VSCodeの**実行とデバッグ**を選択します。メニューから**Listen for Xdebug**を実行するとデバッガが実行されます。
4. PHPのソースコードにブレークポイントを設定すると、Webブラウザからのアクセスに反応します。

## ライセンス

MITライセンスに準じます。

[MIT](./LICENSE)