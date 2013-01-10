
task :composer_setup do
  env = Vagrant::Environment.new ()
  env.primary_vm.channel.sudo("curl -s https://getcomposer.org/installer | php -- --install-dir=bin")
  env.primary_vm.channel.sudo("bin/composer.phar install")
end



bash "assign-postgres-password" do
  user 'root'
  code <<-EOH
echo "ALTER ROLE postgres ENCRYPTED PASSWORD '#{node['postgresql']['password']['postgres']}';" | psql
  EOH
  not_if "echo '\connect' | PGPASSWORD=#{node['postgresql']['password']['postgres']} psql --username=postgres --no-password -h localhost"
  action :run
end