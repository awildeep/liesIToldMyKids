package "php5-curl" do
  action :upgrade
end

package "php-apc" do
  action :install
end

package "php5-mysql" do
  action :install
end

package "php5-pgsql" do
  action :install
end

package "php5-sqlite" do
  action :install
end

package "php5-intl" do
  action :install
end
