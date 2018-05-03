using Npgsql;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Config
{
    public partial class Form1 : Form
    {
        String connString;
        ComboBox groupsChoice = new ComboBox();

        public Form1()
        {
            InitializeComponent();
            databaseTab.TabPages.Remove(tabPage2);
            databaseTab.TabPages.Remove(tabPage3);

            databaseTab.TabPages.Remove(tabPage4);

        }

        private void databaseSubmit_Click(object sender, EventArgs e)
        {
            connString = "Host=" + IPAddress.Text +
                         ";Port=" + port.Text +
                         ";Username=" + username.Text +
                         ";Password=" + password.Text +
                         ";Database=" + databaseName.Text;
            using (var conn = new NpgsqlConnection(connString))
            {
                conn.Open();

                // Retrieve all rows
                using (var cmd = new NpgsqlCommand("SELECT name, price FROM product", conn))
                using (var reader = cmd.ExecuteReader())
                {
                    int count = 0;
                    while (reader.Read())
                    {
                        String text = Convert.ToString(reader.GetValue(0));
                        Double lprice = Convert.ToDouble(reader.GetValue(1));
                        if(count == 0)
                        {
                            productPanel.Controls.Add(new myLabel() { Text = text, Dock = DockStyle.Fill, price = lprice }, 0, productPanel.RowCount - 1);
                        }
                        else
                        {
                            RowStyle temp = productPanel.RowStyles[productPanel.RowCount - 1];
                            productPanel.RowCount++;
                            productPanel.RowStyles.Add(new RowStyle(temp.SizeType, temp.Height));
                            productPanel.Controls.Add(new myLabel() { Text = text, Dock = DockStyle.Fill, price = lprice }, 0, productPanel.RowCount - 1);
                        }
                        count++;
                    }
                }
                conn.Close();

            }

            databaseTab.TabPages.Add(tabPage2);
            databaseTab.SelectedTab = tabPage2;


        }

        private void button1_Click(object sender, EventArgs e)
        {
            if( groupTable.RowCount <= 10)
            {
                RowStyle temp = groupTable.RowStyles[groupTable.RowCount - 1];
                groupTable.RowCount++;
                if(groupTable.RowCount == 10)
                {
                    button1.Enabled = false;
                }
                groupTable.RowStyles.Add(new RowStyle(temp.SizeType, temp.Height));
                groupTable.Controls.Add(new TextBox() { Dock=DockStyle.Fill}, 0, groupTable.RowCount - 1);
                groupTable.Controls.Add(new TextBox() { Dock = DockStyle.Fill }, 1, groupTable.RowCount - 1);
                groupTable.Controls.Add(new TextBox() { Dock = DockStyle.Fill }, 2, groupTable.RowCount - 1);
            }

        }

        private void submitGroupButton_Click(object sender, EventArgs e)
        {
            //Insert into database
            using (var conn = new NpgsqlConnection(connString))
            {
                conn.Open();

                // Insert some data
                using (var cmd = new NpgsqlCommand())
               {
                   cmd.Connection = conn;
                   cmd.CommandText = "DROP TABLE IF EXISTS groups; CREATE TABLE groups (id SERIAL PRIMARY KEY, name text NOT NULL, var DOUBLE PRECISION NOT NULL, margin DOUBLE PRECISION NOT NULL);";
                   cmd.ExecuteNonQuery();
                }
                using (var cmd = new NpgsqlCommand())
                {
                    cmd.Connection = conn;
                    cmd.CommandText = "INSERT INTO groups (name,var,margin) VALUES ";
                    
                    for(int i = 0; i<groupTable.RowCount; i++)
                    {
                        String name = groupTable.GetControlFromPosition(0, i).Text;
                        Double var = Convert.ToDouble(groupTable.GetControlFromPosition(1, i).Text);
                        Double margin = Convert.ToDouble(groupTable.GetControlFromPosition(2, i).Text);
                        if( i == groupTable.RowCount - 1)
                        {
                            cmd.CommandText += "(\'" + name + "\'," + var + "," + margin + ")";

                        }
                        else
                        {
                            cmd.CommandText += "(\'" + name + "\'," + var + "," + margin + "),";

                        }
                    }
                    cmd.CommandText += "RETURNING id;";
                    using (var reader = cmd.ExecuteReader())
                        while (reader.Read())
                            Console.WriteLine(reader.GetString(0));
                }
                conn.Close();
            }

            // For the view
            for (int i = 0; i < groupTable.RowCount; i++)
            {
                String name = groupTable.GetControlFromPosition(0, i).Text;
                if (name != "")
                {
                    groupsChoice.Items.Add(name);
                }
            }

            for (int i = 0; i < productPanel.RowCount; i++)
            {
                ComboBox lnew = new ComboBox();
                for (int j = 0; j < groupsChoice.Items.Count; j++)
                {
                    lnew.Items.Add(groupsChoice.Items[j].ToString());
                }
                productPanel.Controls.Add(lnew, 1, i);
            }

            databaseTab.TabPages.Add(tabPage3);
            databaseTab.SelectedTab = tabPage3;


        }

        private void FinishButton_Click(object sender, EventArgs e)
        {
            using (var conn = new NpgsqlConnection(connString))
            {
                conn.Open();

                // Insert some data
                using (var cmd = new NpgsqlCommand())
                {
                    cmd.Connection = conn;
                    cmd.CommandText = "DROP TABLE IF EXISTS barket; CREATE TABLE barket (id SERIAL PRIMARY KEY, name text NOT NULL, price NUMERIC NOT NULL, delta DOUBLE PRECISION NOT NULL, group_id INTEGER NOT NULL);";
                    cmd.ExecuteNonQuery();
                }
                using (var cmd = new NpgsqlCommand())
                {
                    cmd.Connection = conn;
                    cmd.CommandText = "INSERT INTO barket (name,price,delta,group_id) VALUES ";

                    for (int i = 0; i < productPanel.RowCount; i++)
                    {
                        String name = productPanel.GetControlFromPosition(0, i).Text;
                        Double delta = 0;
                        int groupId = ((ComboBox)productPanel.GetControlFromPosition(1, i)).SelectedIndex + 1;
                        Double price =((myLabel)productPanel.GetControlFromPosition(0, i)).price;
                        if (i == (productPanel.RowCount - 1))
                        {
                            cmd.CommandText += "(\'" + name + "\'," + price + "," + delta + "," + groupId +");";
                        }
                        else
                        {
                            cmd.CommandText += "(\'" + name + "\'," + price + "," + delta + "," + groupId + "),";
                        }
                    }
                    cmd.ExecuteNonQuery();
                }
                conn.Close();
            }
            databaseTab.TabPages.Add(tabPage4);
            databaseTab.SelectedTab = tabPage4;
        }

        private void button2_Click(object sender, EventArgs e)
        {
            Application.Exit();
        }
    }

    public partial class myLabel : Label
    {
        public Double price { get; set; }
    }
}//end namespace
