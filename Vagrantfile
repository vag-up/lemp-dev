# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  # Timeout for booting the VM
  config.vm.boot_timeout = 600

  # Disable auto updating VirtualBox Guest Additions
  if Vagrant.has_plugin?("vagrant-vbguest")
    config.vbguest.auto_update = false
    config.vbguest.no_remote = true
  end

  # VirtualBox image
  config.vm.box = "ubuntu/jammy64"  # OK
  config.vm.box_version = "20241002.0.0"

  # VM spec configuration
  config.vm.provider "virtualbox" do |vb|
    vb.memory = "2048"
  end

  # Network
  config.vm.network "private_network", ip: "192.168.33.10"
  #config.vm.network "public_network", ip: "192.168.1.50"

  # Synced folder
  #config.vm.synced_folder ".", "/vagrant", type: "virtualbox"
  config.vm.synced_folder "./remote", "/var/www/remote", type: "virtualbox"

  # SSH configuration for the VM
  config.vm.provision "shell" do |sh|
    # Local SSH public key
    ssh_pub_key = File.readlines("#{Dir.home}/.ssh/id_ed25519.pub").first.strip

    # Copy SSH public key to the VM
    sh.inline = <<-SHELL
      mkdir -p /root/.ssh/
      echo "#{ssh_pub_key}" > /root/.ssh/authorized_keys
      chmod 700 /root/.ssh
      chmod 600 /root/.ssh/authorized_keys
    SHELL
  end

  # Launch Ansible
  config.vm.provision "ansible_local" do |ansible|
    ansible.become = true
    ansible.playbook = "playbooks/main.yml"
    ansible.galaxy_role_file = "playbooks/requirements.yml"
    ansible.galaxy_command = 'ansible-galaxy install -r %{role_file} --force'
  end
end
